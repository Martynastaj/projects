#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <errno.h>

#define RADIUS 10
#define PIDMIN 2

// odczytanie maksymalnego PID z /proc/sys/kernel/pid_max
int get_pid_max() {
    FILE *file = fopen("/proc/sys/kernel/pid_max", "r");
    if (!file) {
        perror("Nie można otworzyć /proc/sys/kernel/pid_max");
        exit(EXIT_FAILURE);
    }

    int pid_max;
    if (fscanf(file, "%d", &pid_max) != 1) {
        perror("Nie można odczytać pid_max");
        fclose(file);
        exit(EXIT_FAILURE);
    }

    fclose(file);
    return pid_max;
}

// obliczenie listy PIDow z zawijaniem
void calculate_pids(int base_pid, int radius, const int pid_max, char **pid_list, int *count, int *start, int *end) {
    *start = base_pid - radius; // pierwszy pid
    *end = base_pid + radius;    // ostatni pid

    *count = 0;

    for (int i = *start; i <= *end; i++) {
        int pid = i;
        if (pid < PIDMIN) {
            pid += pid_max; // zawijanie na dole
        } else if (pid > pid_max) {
            pid -= pid_max; // zawijanie u gory
        }
        asprintf(&pid_list[(*count)++], "%d", pid);
    }
}

int main(int argc, char *argv[]) {
    const int PIDMAX = get_pid_max();       
    int pid = getppid();                  
    int radius = RADIUS;           

    int opt;
    while ((opt = getopt(argc, argv, "p:s:")) != -1) {
        switch (opt) {
            case 'p':
                pid = atoi(optarg);
                if (pid < PIDMIN || pid > PIDMAX) {
                    perror("Nieprawidlowy PID");
                    exit(EXIT_FAILURE);
                }
                break;
            case 's':
                radius = atoi(optarg);
                if (radius < 0) {
                    perror("Nieprawidlowy promien");
                    exit(EXIT_FAILURE);
                }
                break;
            default:
                perror("Nieprawidlowe uzycie");
                exit(EXIT_FAILURE);
        }
    }

    // obliczanie listy PIDow
    char *pid_list[ 1 + 2 * radius ];
    int pid_count = 0;
    int start, end;
    calculate_pids(pid, radius, PIDMAX, pid_list, &pid_count, &start, &end);

    // wyswietlanie informacji
    printf("PIDMAX: %d\n", PIDMAX);
    printf("Liczba PIDow w zakresie: %d\n\n", pid_count);

    printf("Parametry:\n");
    printf("PID: %d\n", pid);
    printf("Promień: %d\n", radius);
    printf("\n");
    // przygotowanie argumentów do ps
    char *ps_args[3 + pid_count + 1];
    ps_args[0] = "ps";
    ps_args[1] = "-o";
    ps_args[2] = "pid,ppid,exe,args";
    for (int i = 0; i < pid_count; i++) {
        ps_args[3 + i] = pid_list[i];
    }
    ps_args[3 + pid_count] = NULL;

    // uruchomienie ps
    execvp("ps", ps_args);

    perror("Nie udało się uruchomić ps");

    // czyszczenie
    for (int i = 0; i < pid_count; i++) {
        free(pid_list[i]);
    }
    exit(EXIT_FAILURE);
}
